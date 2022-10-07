import {profile, profiles} from '../helpers/profiles'
export const portFacilitiesRoutes = [
  {
    path: '/PortFacilities',
    redirect: '/PortFacilities/Dashboard',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Dashboard',
        meta: { authorize: [profile.PortFacilities] },
        component: () => import('../components/PortFacilities/Kanban.vue')
      },
      {
        path: 'Info',
        meta: { authorize: [profile.PortFacilities] },
        component: () => import('../components/PortFacilities/PortFacilitiesInfo.vue')
      }
    ]
  },
  {
    path: '/PortFacilities',
    component: () => import('../views/PortFacilities.vue'),
    children:[
      {
        path: 'Create',
        meta: { authorize: [profile.PortFacilities] },
        component: () => import('../components/PortFacilities/PortFacilitiesForm.vue')
      }
    ]
  }
]
