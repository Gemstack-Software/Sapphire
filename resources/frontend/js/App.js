import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import PrimeVue from 'primevue/config';
import lower from './utils/Lower'
import SetupUser from './pages/SetupUser.vue'
import Login from './pages/Login.vue'
import Content from './pages/Content.vue'
import Assets from './pages/Assets.vue'
import Pages from './pages/Pages.vue'
import Sidebar from './components/Sidebar.vue'
import InfoBox from './components/InfoBox.vue'
import AppEditor from './Pages/AppEditor.vue'
import Disk from './Pages/Disk.vue'
import Plugins from './Pages/Plugins.vue'
import Settings from './pages/Settings.vue'
import NewUserSetup from './pages/NewUserSetup.vue'
import Account from './pages/Account.vue'
import AOS from 'aos'
import 'aos/dist/aos.css'
import { GetDiskSpace } from './utils/DiskSpace'
import { GetSalesEarnings } from './utils/SalesEarnings'

const app = createApp({
  components: lower({
    ...window.additionalVueComponents,
    SetupUser,
    Login,
    Sidebar,
    InfoBox,
    Content,
    Assets,
    Pages,
    AppEditor,
    Disk,
    Plugins,
    Settings,
    NewUserSetup,
    Account
  }),
  methods: {
    GetDiskSpace,
    GetSalesEarnings
  },
  mounted() {
    AOS.init()
  }
})

app.use(
  VueTippy,
  {
    directive: 'tippy',
    component: 'tippy',
    componentSingleton: 'tippy-singleton',
    defaultProps: {
      allowHTML: true,
    },
  }
)

app.use(PrimeVue)

app.mount('#cms-app__root')