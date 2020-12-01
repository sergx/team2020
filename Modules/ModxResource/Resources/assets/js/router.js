import VueRouter from 'vue-router';
import FastEdit  from './components/FastEdit';
import notFound404  from './components/notFound404';
//import FastEditUserPermission  from './components/FastEditUserPermission';
//import ModuleBuyerIndex  from './components/ModuleBuyerIndex';


export default new VueRouter({
  mode: "history",
  routes: [
    {path: '/fastedit/:user_id(\\d+)', component: FastEdit, name: 'FastEdit',},
    {path: '/fastedit/user_permission/:user_id(\\d+)', component: FastEdit, name: 'FastEditUserPermission'},
    {path: '*', component: notFound404, name: 'notFound404'},
    //{path: '/buyer', component: ModuleBuyerIndex},
  ],
});
