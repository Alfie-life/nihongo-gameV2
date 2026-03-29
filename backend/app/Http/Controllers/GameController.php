<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\FoodItem;
use App\Models\FoodCollection;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Get levels for a mode with user progress
     */
    public function levels(Request $request, string $mode)
    {
        $user = $request->user();
        $levels = [];

        for ($i = 1; $i <= 10; $i++) {
            $totalQuestions = Question::where('mode', $mode)->where('level', $i)->count();
            $progress = UserProgress::where('user_id', $user->id)
                ->where('mode', $mode)
                ->where('level', $i)
                ->first();

            $levels[] = [
                'level' => $i,
                'total_questions' => $totalQuestions,
                'current_question' => $progress ? $progress->current_question : 0,
                'is_completed' => $progress ? $progress->is_completed : false,
                'is_unlocked' => $i === 1 || ($this->isLevelCompleted($user->id, $mode, $i - 1)),
            ];
        }

        return response()->json($levels);
    }

    /**
     * Get the next question for a level
     */
    public function nextQuestion(Request $request, string $mode, int $level)
    {
        $user = $request->user();

        $progress = UserProgress::firstOrCreate(
            ['user_id' => $user->id, 'mode' => $mode, 'level' => $level],
            ['current_question' => 0, 'is_completed' => false]
        );

        if ($progress->is_completed) {
            return response()->json([
                'completed' => true,
                'message' => 'このレベルはクリア済みです！ / Level already completed!',
            ]);
        }

        $questions = Question::where('mode', $mode)
            ->where('level', $level)
            ->orderBy('id')
            ->get();

        if ($progress->current_question >= $questions->count()) {
            $progress->update(['is_completed' => true]);
            return response()->json([
                'completed' => true,
                'message' => 'レベルクリア！ / Level Complete!',
            ]);
        }

        $question = $questions[$progress->current_question];

        return response()->json([
            'completed' => false,
            'question_number' => $progress->current_question + 1,
            'total_questions' => $questions->count(),
            'question' => [
                'id' => $question->id,
                'sentence' => $question->sentence,
                'left_choice' => $mode === 'aru_iru' ? 'ある' : 'だし',
                'right_choice' => $mode === 'aru_iru' ? 'いる' : 'し',
            ],
        ]);
    }

    /**
     * Submit an answer
     */
    public function answer(Request $request, string $mode, int $level)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);

        $user = $request->user();
        $question = Question::findOrFail($request->question_id);

        $isCorrect = $question->correct_answer === $request->answer;

        if ($isCorrect) {
            $progress = UserProgress::where('user_id', $user->id)
                ->where('mode', $mode)
                ->where('level', $level)
                ->first();

            if ($progress) {
                $questionIndex = $progress->current_question;
                $progress->increment('current_question');

                // Check if level is now complete
                $totalQuestions = Question::where('mode', $mode)->where('level', $level)->count();
                if ($progress->current_question >= $totalQuestions) {
                    $progress->update(['is_completed' => true]);
                }

                // Award food item
                $foodItem = FoodItem::where('mode', $mode)
                    ->where('level', $level)
                    ->where('question_index', $questionIndex)
                    ->first();

                if ($foodItem) {
                    $collection = FoodCollection::firstOrCreate(
                        ['user_id' => $user->id, 'food_item_id' => $foodItem->id],
                        [
                            'mode' => $mode,
                            'level' => $level,
                            'obtained_at' => now(),
                        ]
                    );

                    return response()->json([
                        'correct' => true,
                        'explanation' => $question->explanation,
                        'food_item' => [
                            'name' => $foodItem->name,
                            'name_en' => $foodItem->name_en,
                            'emoji' => $foodItem->emoji,
                            'category' => $foodItem->category,
                            'is_new' => $collection->wasRecentlyCreated,
                        ],
                        'level_completed' => $progress->is_completed,
                    ]);
                }
            }

            return response()->json([
                'correct' => true,
                'explanation' => $question->explanation,
                'food_item' => null,
                'level_completed' => $progress ? $progress->is_completed : false,
            ]);
        }

        return response()->json([
            'correct' => false,
            'explanation' => $question->explanation,
            'correct_answer' => $question->correct_answer,
        ]);
    }

    /**
     * Get user's food collection (図鑑)
     */
    public function collection(Request $request)
    {
        $user = $request->user();

        $collected = FoodCollection::where('user_id', $user->id)
            ->with('foodItem')
            ->orderBy('obtained_at', 'desc')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->food_item_id,
                    'name' => $c->foodItem->name,
                    'name_en' => $c->foodItem->name_en,
                    'emoji' => $c->foodItem->emoji,
                    'category' => $c->foodItem->category,
                    'mode' => $c->mode,
                    'level' => $c->level,
                    'obtained_at' => $c->obtained_at->toDateTimeString(),
                ];
            });

        $totalItems = FoodItem::count();

        return response()->json([
            'collected' => $collected,
            'total_items' => $totalItems,
            'collected_count' => $collected->count(),
        ]);
    }

    /**
     * Reset progress for a mode/level (replay)
     */
    public function resetLevel(Request $request, string $mode, int $level)
    {
        $user = $request->user();

        UserProgress::where('user_id', $user->id)
            ->where('mode', $mode)
            ->where('level', $level)
            ->update(['current_question' => 0, 'is_completed' => false]);

        return response()->json(['message' => 'リセットしました / Level reset']);
    }

    private function isLevelCompleted(int $userId, string $mode, int $level): bool
    {
        return UserProgress::where('user_id', $userId)
            ->where('mode', $mode)
            ->where('level', $level)
            ->where('is_completed', true)
            ->exists();
    }
}
