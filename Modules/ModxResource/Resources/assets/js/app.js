window.Vue = require('vue');
import VueRouter from 'vue-router';
import router from './router';
Vue.use(VueRouter);
//window.axios = require('axios');



import App from './components/App';
const app = new Vue({
  'el' : '#app',
  render : r => r(App),
  router,
  methods:{
    ajax_basic: function(DataToGo, url){
      return axios({
          method: 'post',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          //headers: { 'Content-Type': 'application/json' },
          url: url,
          data: DataToGo
        }
      )
      .then(response =>{
        if (typeof response.data !== 'object') {
          return Promise.reject(response.data);
        }
        return response;
      })
      .catch(function (error) {
        console.group("Axios catch error");
        console.warn(error);
        if(error.response !== undefined){
          console.warn(error.response);
        }
        console.groupEnd();
      });
    },
    unique: function (arr) {
      var hash = {}, result = [];
      for ( var i = 0, l = arr.length; i < l; ++i ) {
        if ( !hash.hasOwnProperty(arr[i]) ) { //it works with objects! in FF, at least
          hash[ arr[i] ] = true;
          result.push(arr[i]);
        }
      }
      return result;
    }
  }
  //components: {
  //  App,
  //}
});
