import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

export default createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'nihongoTheme',
    themes: {
      nihongoTheme: {
        dark: false,
        colors: {
          primary: '#E8594F',
          secondary: '#2D2D2D',
          accent: '#F5A623',
          success: '#4CAF50',
          warning: '#FF9800',
          error: '#E8594F',
          background: '#FFF8F0',
          surface: '#FFFFFF',
          'on-background': '#2D2D2D',
          'on-surface': '#2D2D2D',
        },
      },
    },
  },
  defaults: {
    VBtn: {
      rounded: 'lg',
      elevation: 0,
    },
    VCard: {
      rounded: 'xl',
      elevation: 2,
    },
  },
})
