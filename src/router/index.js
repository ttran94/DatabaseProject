import Vue from 'vue'
import index from '@/components/index.vue'
import Login from '@/components/login/login.vue'
import Register from '@/components/register/register.vue'
import Scientist from '@/components/city_scientist/scientist.vue'
import ScientistDefault from '@/components/city_scientist/default/default.vue'
import DataPoint from '@/components/city_scientist/data_point/data_point.vue'
import ADDPOI from '@/components/city_scientist/poi/add_poi.vue'


import Admin from '@/components/admin/admin.vue'
import AdminDefault from '@/components/admin/default/default.vue'
import PendingDataPoint from '@/components/admin/pending_data/pending_data.vue'
import PendingOfficial from '@/components/admin/pending_official/pending_official.vue'



const routes = [
  {
    path: '/',
    component: index,
    children: [
      {
        path: '/login',
        name: 'Login',
        component: Login,
      },
      {
        path: '/register',
        name: 'Register',
        component: Register,
      }
    ]
  },
  {
    path: '/scientist',
    component: Scientist,
    children: [
      {
        path: '',
        component: ScientistDefault,
        name: 'ScientistDefault',
      },
      {
        path: 'addpoint',
        component: DataPoint,
        name: 'addpoint',
      },
      {
        path: 'addpoi',
        component: ADDPOI,
        name: 'addpoi',
      }
    ]
  },
  {
    path: '/admin',
    component: Admin,
    children: [
      {
        path: '',
        component: AdminDefault,
        name: 'AdminDefault',
      },
      {
        path: 'pendingdata',
        component: PendingDataPoint,
        name: 'PendingDataPoint',
      },
      {
        path: 'pendingofficial',
        component: PendingOfficial,
        name: 'PendingOfficial',
      }
    ]
  }
]

export default routes
