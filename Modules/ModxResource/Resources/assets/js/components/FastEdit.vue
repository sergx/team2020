<template>
  <div class="resource_edit">
    <h1 class="mb-3" v-if="$route.name == 'FastEditUserPermission'">Редактирование доступа к редактированию цен для <a :href="'/user/'+$route.params.user_id" target="_blank">пользователя</a></h1>
    <h1 class="mb-3" v-if="$route.name == 'FastEdit'">Редактирование контактных данных и цен</h1>
    <div class="settings" v-if="$route.name == 'FastEditUserPermission' && cites_data.length">
      <!-- <h2>Список городов</h2> -->
      <div class="city_list_wr">
        <!--<div class="title" v-if="$route.name == 'FastEdit'"><label><input type="checkbox" @change="toggleAllCity"> <span>Все города</span></label></div>-->
        <div class="city_list">
          <checkbox-radio-item
            v-for="(city, index) in cites_data"
            :key="index"
            type="checkbox"
            :css_style="style.cites_data"
            :val="city"
            v-model="cites_selected"
          >{{city.menutitle}}</checkbox-radio-item>
        </div>
      </div>
      <!--<div class="stat_days"><input type="number" placeholder="Кол-во дней" v-model="stat_days"></div>-->
    </div>
    <div v-else-if="$route.name == 'FastEditUserPermission' && !cites_data.length">
      <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span>
      </button>
    </div>

    <div v-if="cites_selected.length">
      <h2 class="mt-4 mb-3">Доступные города</h2>

      <div class="btn-group btn-group-toggle">
        <checkbox-radio-item
          v-for="(city, index) in cites_selected"
          :key="index"
          type="radio"
          :css_style="style.cites_selected"
          :val="city"
          v-model="city_to_edit"
        >{{city.menutitle}} ({{city.materials_saved.length}})</checkbox-radio-item>
      </div>
      <!-- <h2 v-if="city_to_edit.id && $route.name == 'FastEditUserPermission'" class="mt-4">{{city_to_edit.menutitle}} — Материалы в городе</h2> -->
      <h2 class="mt-4 mb-3" v-if="city_to_edit.id">{{city_to_edit.menutitle}} — материалы в городе</h2>
      <button @click="userPermissionUpdate"
        v-if="city_to_edit.id && $route.name == 'FastEditUserPermission'"
        class="btn btn-outline-primary btn-sm mb-3">
        Сохранить набор материалов ({{materials_selected.length}} шт.)
        <span v-if="ui.userPermissionUpdate_isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      </button>
    </div>

    <div class="table-responsive-lg" v-if="city_to_edit.id">
      <div class="table">
        <div class="td_row thead" v-if="$route.name == 'FastEdit'">
          <div class="td_material">Материал</div>
          <div class="td_price">Цена за 1 кг</div>
          <div class="td_phone">Телефон</div>
          <div class="td_email">Email</div>
          <!--<div class="td_stat">Статистика</div>-->
        </div>
        <div class="td_row" v-if="$route.name == 'FastEdit'">
          <div class="td_material"></div>
          <div class="td_price"></div>
          <div class="td_phone input-group">
            <input :disabled="!is_materials_selected" v-model="selectedUpdate_data.phone" @keyup.enter="updateFieldSelected(selectedUpdate_data.phone, 'phone')" type="tel" class="form-control" placeholder="Для всех отмеченных">
            <div class="input-group-append" v-if="is_materials_selected">
              <button class="btn btn-primary" @click="updateFieldSelected(selectedUpdate_data.phone, 'phone')">Ок</button>
            </div>
          </div>
          <div class="td_email input-group">
            <input :disabled="!is_materials_selected" v-model="selectedUpdate_data.email" @keyup.enter="updateFieldSelected(selectedUpdate_data.email, 'email')" type="email" class="form-control" placeholder="Для всех отмеченных">
            <div class="input-group-append" v-if="is_materials_selected">
              <button class="btn btn-primary" @click="updateFieldSelected(selectedUpdate_data.email, 'email')">Ок</button>
            </div>
          </div>
          <!--<div class="td_stat"></div>-->
        </div>
        
        <page-row
          v-for="(material, index) in materials_tree_list"
          :key="index"
          :page="material"
          :level="1"
          :m_val="material"
          :aproved_materials="city_to_edit.materials_saved"
          :is_materials_selected="is_materials_selected"
          :active_city_id="city_to_edit.id"
          v-model="materials_selected"
          @updateField="updateField"
        ></page-row>

      </div>
    </div>
    <div v-else-if="$route.name == 'FastEdit' && !cites_data.length">
      <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span>
      </button>
    </div>
    <div v-if="$route.name == 'FastEdit' && cites_selected.length">
      <hr>
      <h3>Изменить для всех доступных</h3>
      <p>Тут можно отредактировать телефон и почту сразу для всех доступных материалов во всех городах</p>
      <div class="row">
        <div class="input-group mb-3 col-sm-12 col-md-6 col-lg-5 col-xl-4">
          <div class="input-group-prepend d-none d-sm-flex">
            <span class="input-group-text">Телефон</span>
          </div>
          <input type="tel" class="form-control" v-model="massUpdate_data.phone" placeholder="Введите телефон">
          <div class="input-group-append">
            <button class="btn btn-primary" @click="updateAll(massUpdate_data.phone, 'phone')">
              Сохранить
              <span v-if="ui.massUpdatePhone_isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </div>
        <div class="input-group mb-3 col-sm-12 col-md-6 col-lg-5 col-xl-4">
          <div class="input-group-prepend d-none d-sm-flex">
            <span class="input-group-text">Email</span>
          </div>
          <input type="email" class="form-control" v-model="massUpdate_data.email" placeholder="Введите Email">
          <div class="input-group-append">
            <button class="btn btn-primary" @click="updateAll(massUpdate_data.email, 'email')">
              Сохранить
              <span v-if="ui.massUpdateEmail_isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import PageRow from './PageRow';
  import CheckboxRadioItem from './CheckboxRadioItem';
  export default {
    data(){
      return {
        cites_data:[],
        cites_selected:[],
        materials_selected:[],
        //materials_selected_ids:[], // Helper при обновлении данных
        city_is_all:false,
        stat_days:30,

        materials_tree_list:[],
        url:{
          cites_data: "/api/fastedit/get-city-list",
          update_field: "/api/fastedit/update-field",
          materials_tree_list: "/api/fastedit/get-material-tree",
          user_permission_get: "/api/fastedit/user-permission-get",
          user_permission_update: "/api/fastedit/user-permission-update",
        },
        city_to_edit:{}, // permissions
        mic_permissions:Object, // materials_in_city,
        ui:{
          userPermissionUpdate_isLoading:false,
          massUpdatePhone_isLoading:false,
          massUpdateEmail_isLoading:false,
        },
        style:{
          cites_selected:{
            label_class: 'btn btn-outline-primary',
            label_class_active: 'btn btn-primary',
            input_class: 'btn',
          },
          cites_data:{ label_class: 'item'}
        },
        selectedUpdate_data:{
          phone:"",
          email:"",
        },
        massUpdate_data:{
          phone:"",
          email:"",
        }
      }
    },
    components:{
      PageRow,
      CheckboxRadioItem,
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
    },
    mounted(){

      if(this.$route.name == "FastEditUserPermission"){
        this.$root.ajax_basic({userPermissions: []}, this.url.materials_tree_list).then(response => {
          this.materials_tree_list = response.data.data;
          return this.$root.ajax_basic({user_id:parseInt(this.$route.params.user_id)}, this.url.user_permission_get).then(response => {
            return this.getCityList().then(() => {
              this.userPermissionGet(response.data);
            });
          });

        });
      }else if(this.$route.name == "FastEdit"){
        this.loadData_FastEdit();
      }
    },
    methods:{
      loadData_FastEdit: function(){
        return this.$root.ajax_basic({user_id:parseInt(this.$route.params.user_id)}, this.url.user_permission_get).then(response => {
          let userPermissions = response.data;
          if(!Object.keys(userPermissions).length){
           //return this.error_redirect();
           alert("Нет прав для редактирования. \r\n(Адрес страницы — "+window.location.pathname+")");
          }
          return this.$root.ajax_basic({userPermissions: userPermissions}, this.url.materials_tree_list).then(response => {
            this.materials_tree_list = response.data.data;
            return this.getCityList(userPermissions).then(() => {
              this.userPermissionGet(userPermissions);
            });
          });
        });
      },
      getCityList: function(userPermissions){
        let dataToGo = {};
        if(userPermissions && Object.keys(userPermissions).length){
          dataToGo = {city_ids: Object.keys(userPermissions)};
        }
        return this.$root.ajax_basic(dataToGo, this.url.cites_data).then(response => {
          this.cites_data = response.data.data.map(city => {
            city.materials_saved = [];
            city.materials_selected = [];
            return city;
          });
        });
      },
      userPermissionGet:function(data){
        for(let city_id in data){
          let arr = [];
          data[city_id].map(material_id => {
            this.materials_tree_list.map(level1 => {
              if(level1.id == material_id){
                arr.push(level1);
              }else if(level1.children.length){
                level1.children.map(level2 => {
                  if(level2.id == material_id){
                    arr.push(level2);
                  }else if(level2.children.length){
                    level2.children.map(level3 => {
                      if(level3.id == material_id){
                        arr.push(level3);
                      }
                    });
                  }
                });
              }
            });
          });
          this.cites_data.map(city => {
            if(city.id == city_id){
              city.materials_selected = arr;
              city.materials_saved = arr;
              if(this.cites_selected.map(city_sel => city_sel.id).indexOf(city.id) === -1){
                this.cites_selected.push(city);
              }
            }
          });
        }
        if(this.cites_selected.length){
          this.city_to_edit = this.cites_selected[0];
          //this.reSelectMaterials();
        }
      },
      userPermissionUpdate:function(){
        this.ui.userPermissionUpdate_isLoading = true;
        this.$root.ajax_basic({
          materials: this.materials_selected.map(material => material.id),
          city_id: this.city_to_edit.id,
          user_id: parseInt(this.$route.params.user_id),
          }, this.url.user_permission_update).then(response => {
            this.userPermissionGet(response.data);
            this.ui.userPermissionUpdate_isLoading = false;
          });
      },
      toggleAllCity:function(e){
        if(e.target.checked){
          this.cites_selected = this.cites_data;
        }else{
          this.cites_selected = [];
        }
      },
      updateAll: function(val, type){
        switch(type){
          case "phone": this.ui.massUpdatePhone_isLoading = true; break;
          case "email": this.ui.massUpdateEmail_isLoading = true; break;
        }
        let count = this.cites_selected.length;
        this.cites_selected.map((city, i, arr) => {
          let dataToSend = {
            value: val,
            type: type,
            city_id: city.id,
            material_ids: city.materials_saved.map(material => material.id),
          }
          console.log(dataToSend);
          this.updateField(dataToSend).then(() => {
            if(--count === 0){
              this.loadData_FastEdit().then(() => {
                console.log("ok");
                switch(type){
                  case "phone": this.ui.massUpdatePhone_isLoading = false; break;
                  case "email": this.ui.massUpdateEmail_isLoading = false; break;
                }
              });
            }
          });
        });


      },
      updateFieldSelected: function(val, type){
        //console.log(this.materials_selected.map(material => material.id));
        this.updateField({
          value: val,
          type: type,
          city_id: this.city_to_edit.id,
          material_ids: this.materials_selected.map(material => material.id),
        }).then(() => {

          // this.loadData_FastEdit().then(() => {
          //   e.target.value = "";
          //   });
          });
      },
      updateField: function(data){
        //console.log(data);
        return this.$root.ajax_basic(
          Object.assign(data, {
            user_id: this.$route.params.user_id,
            }),
          this.url.update_field).then(response => {
            // Обработка ошибок!
            this.materials_selected.filter(material => {
              if(data.material_ids.indexOf(material.id) !== -1){
                return true;
              }
            }).map(material => {
              if(["phone", "email"].indexOf(data.type) !== -1){
                let tv = material.mic.filter(mic => mic.st_city_id == data.city_id).map(mic => {
                  let val_tv = mic.tv.filter(tv => tv.name == data.type);
                  if(val_tv.length){
                    val_tv[0].value = data.value;
                    //console.log(val_tv[0].value);
                  }
                });

              }else if(data.type == "material_price"){
                
              }
            });
            //console.log(response.data);
        });
      },
      error_redirect: function(){
        window.location.href = window.location.origin + '/fastedit/not-found';
      }
      // reSelectMaterials: function(){
      //   // Почему-то не признает он эти материалы. Почем-то они реактивные..
      //   if(this.materials_selected_ids.length){
      //     console.log(this.materials_selected_ids);
      //     this.materials_selected = this.city_to_edit.materials_selected.filter(material => {
      //       if(this.materials_selected_ids.indexOf(material.id) !== -1){
      //         console.log(material.id);
      //         return true;
      //       }
      //     });
      //     console.log(this.materials_selected);
      //     this.materials_selected_ids = [];
      //   }
      // }
    },
    watch:{
      city_to_edit:function(val){
        //console.log(val);
        if(this.$route.name == "FastEditUserPermission"){
          this.materials_selected = val.materials_selected;
        }else{
          this.materials_selected = [];
        }
      }
    }
  }
</script>


<style>
.table{
  min-width:800px;
}
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
@media (max-width:991px) {  
  .resource_edit{
    padding: 0 15px;
  }
  .table{
	  margin-left: 25px;
  }
  .table-responsive-lg{
    box-shadow: 0 0 10px #ccc;
    padding: 20px;
    margin: 15px -15px;
    width: 100vw;
  }
}
@media (min-width:992px) {  
  .resource_edit{
    padding: 0 50px;
  }

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
/*
.td_row input[type="text"],
.td_row input[type="email"],
.td_row input[type="tel"]{
  width: 100%;
}
*/
.settings .city_list{
  display: flex;
  flex-wrap: wrap;
}
.td_material{
  flex-basis: 40%;
  flex-shrink: 0;
  min-height: 31px;
  position: relative;
}
.td_price{
  flex-basis: 20%;
  flex-shrink: 0;
  padding: 0 5px;
}
.td_phone{
  flex-basis: 20%;
  flex-shrink: 0;
  padding: 0 5px;
}
.td_email{
  flex-basis: 20%;
  flex-shrink: 0;
  padding: 0 5px;
}
.td_stat{
  flex-basis: 20%;
  flex-shrink: 0;
  padding: 0 5px;
}
.has_chidren > .td_row{
  font-weight: bold;
}
</style>
