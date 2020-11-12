<template>
  <div>
    <div class="table-responsive mb-3">
      <table class="table">
        <thead>
          <tr>
            <th scope="col" class="text-nowrap">Имя / Организация</th>
            <th scope="col" class="text-nowrap">Местоположение</th>
            <th scope="col" class="text-nowrap">Комментарий</th>
            <th scope="col" class="text-nowrap">Договор</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" v-bind:key="item.id">
            <td><a :href="route('api.buyer.show', item.id)">{{item.name}}</a></td>
            <td>{{item.place}}</td>
            <td>{{item.description}}</td>
            <td>{{item.has_contract}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import laraRoute from '../route';

  export default {
    data(){
      return {
        items : [],
      }
    },
    mounted(){
      this.getItems();
    },
    // computed:{
    //   link:{
    //     function () {
          
    //     }
    //   }
    // },
    methods:{
      getItems(){
        axios.get(laraRoute('api.buyer.index')).then((response) => {
          console.log(response.data.data);
          this.items = response.data.data;
        });
      },
      route(){
        return laraRoute(...arguments);
      }
    }
  }
</script>
