<template>
  <div class="resource_edit">
    <div class="settings">
      <div class="city_list_wr">
        <div class="title"><label><input type="checkbox" @change="toggleAllCity"> <span>Все города</span></label></div>
        <div class="city_list">
          <checkbox-item
            v-for="(city, index) in cites_data"
            :key="index"
            :val="city.id"
            v-model="cites_selected"
          >{{city.menutitle}}</checkbox-item>
        </div>
      </div>
      <!--<div class="stat_days"><input type="number" placeholder="Кол-во дней" v-model="stat_days"></div>-->
    </div>

    <div class="city_list_warning">
      <h2 v-if="cites_selected.length > 0 && !is_all_city_selected">
        Изменения в городах — 
        {{cites_selected_names.join(", ")}}
      </h2>
      <h2 v-else-if="is_all_city_selected">
        Изменения во всех городах
      </h2>
    </div>

    <div class="table">
      <page-row
        v-for="(material, index) in materials_tree_list"
        :key="index"
        :page="material"
        :level="1"
        :m_val="material.st_material_id"
        :is_materials_selected="is_materials_selected"
        v-model="materials_selected"
        @updateField="updateField"
      ></page-row>

    </div>
  </div>
</template>
<script>
  import PageRow from './PageRow';
  import CheckboxItem from './CheckboxItem';
  export default {
    data(){
      return {
        cites_data:[],
        cites_selected:[],
        materials_selected:[],
        city_is_all:false,
        stat_days:30,
        materials_tree_list:[],
        url:{
          update_field: "http://loc-team2020.test/api/fastedit/update-field",
          materials_tree_list: "http://loc-team2020.test/api/fastedit/get-material-tree/18884",
          cites_data: "http://loc-team2020.test/api/fastedit/get-city-list",
        },
      }
    },
    components:{
      PageRow,
      CheckboxItem,
    },
    computed:{
      is_all_city_selected: function(){
        if(this.cites_selected.length > 0 && this.cites_selected.length == this.cites_data.length){
          return true;
        }else{
          return false;
        }
      },
      is_materials_selected:function(){
        return !!this.materials_selected.length;
      },
      cites_selected_names: function(){
        return this.cites_data.map(city => {
          if(this.cites_selected.indexOf(city.id) != -1){
            return city.menutitle;
          }
        }).filter(city => !!city);
      }
    },
    mounted(){
      this.$root.ajax_basic({}, this.url.materials_tree_list).then(response => {
        this.materials_tree_list = response.data.data;
      });
      this.$root.ajax_basic({}, this.url.cites_data).then(response => {
        this.cites_data = response.data.data;
      });
    },
    methods:{
      toggleAllCity:function(e){
        if(e.target.checked){
          this.cites_selected = this.cites_data.map(city => city.id);
        }else{
          this.cites_selected = [];
        }
      },
      updateFieldSelected: function(e, type){
        this.updateField({
          value: e.target.value,
          type: type,
          base_material_ids: this.materials_selected,
        });
      },
      updateField: function(data){
        if(this.cites_selected.length){
          this.$root.ajax_basic(Object.assign(data, {cites_selected: this.cites_selected}), this.url.update_field).then(response => {
            console.log(response.data);
          });
        }else{
          alert("Не выбран город");
        }
      }
    }
  }
</script>


<style>
.city_list{
  display: flex;
  flex-wrap: wrap;
}
.city_list .item{
  margin-right: 10px;
  flex-basis: 180px;
  flex-shrink: 0;
}
.city_list .item input{
  margin-right: 4px;
}
.resource_edit{
  padding: 0 50px;
}
.table .td_row{
  display: flex;
  justify-content: space-between;
  flex-shrink: 0;
  margin-bottom: 4px;
  justify-content: flex-start;
  align-items: center;
}
.table .td_row.thead{
  font-weight: bold;
  font-size: 1.15em;
}
.td_row input{
  max-width: 150px;
}
.settings .city_list{
  display: flex;
  flex-wrap: wrap;
}
.td_material{
  flex-basis: 40%;
  flex-shrink: 0;
  position: relative;
}
.td_price{
  flex-basis: 20%;
  flex-shrink: 0;
}
.td_phone{
  flex-basis: 20%;
  flex-shrink: 0;
}
.td_email{
  flex-basis: 20%;
  flex-shrink: 0;
}
.td_stat{
  flex-basis: 20%;
  flex-shrink: 0;
}
.has_chidren > .td_row{
  font-weight: bold;
}
</style>
