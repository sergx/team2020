import VueRouter from 'vue-router';
import FastEdit  from './components/FastEdit';
import notFound404  from './components/notFound404';
//import FastEditUserPermission  from './components/FastEditUserPermission';
//import ModuleBuyerIndex  from './components/ModuleBuyerIndex';


export default new VueRouter({
  mode: "history",
  routes: [
    {path: '/fastedit/user_price/:id(\\d+)', component: FastEdit, name: 'FastEditUserPrice'},
    {path: '/fastedit/user_permission/:id(\\d+)', component: FastEdit, name: 'FastEditUserPermission'},
    {path: '/fastedit/punktpriem_permission/:id(\\d+)', component: FastEdit, name: 'FastEditPunktPriemPermission'},
    {path: '*', component: notFound404, name: 'notFound404'},
    //{path: '/buyer', component: ModuleBuyerIndex},
  ],
});
