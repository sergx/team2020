import VueRouter from 'vue-router';
import ExampleComponent  from './components/ExampleComponent';
import ModuleBuyerIndex  from './components/ModuleBuyerIndex';


export default new VueRouter({
  //mode: "history",
  routes: [
    {path: '/example-component', component: ExampleComponent},
    {path: '/buyer', component: ModuleBuyerIndex},
  ],
});
