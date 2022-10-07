import {profile, profiles} from '../helpers/profiles'
export const mooringOperatorsRoutes = [
  {
    path: '/MooringOperators',
    redirect: '/MooringOperators/info',
    component: () => import('../views/AdminIndex.vue'),
    children:[
      {
        path: 'Info',
        meta: { authorize: [profile.MooringOperators] },
        component: () => import('../components/MooringOperators/MooringOperatorsInfo.vue')
      }
    ]
  },
  {
    path: '/MooringOperators',
    component: () => import('../views/MooringOperators.vue'),
    children:[
      {
        path: 'Create',
        meta: { authorize: [profile.MooringOperators] },
        component: () => import('../components/MooringOperators/MooringOperatorsForm.vue')
      }
    ]
  },
]
