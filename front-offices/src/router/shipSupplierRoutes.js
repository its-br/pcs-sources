import {profile, profiles} from '../helpers/profiles'
export const shipSupplierRoutes = [
  {
    path: '/ShipSupplier',
    redirect: '/ShipSupplier/info',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.ShipSupplier] },
        component: () => import('../components/ShipSupplier/ShipSupplierInfo.vue')
      }
    ]
  },
  {
    path: '/ShipSupplier',
    component: () => import('../views/ShipSupplier.vue'),
    children:[
      {
        path: 'Create',
        meta: { authorize: [profile.ShipSupplier] },
        component: () => import('../components/ShipSupplier/ShipSupplierForm.vue')
      }
    ]
  }
]
