<template>
  <div class="page_row_item" :class="classArray">
    <div class="td_row">
      <div class="td_material">
        <div class="show_children" v-if="has_chidren" @click="toggleShowChildren">
          <span v-if="!show_children">+</span>
          <span v-if="show_children">–</span>
        </div>
        <label><input :disabled="$route.name == 'FastEditUserPrice' && !is_this_approved" type="checkbox" v-model="m_model" :value="m_val" @change="toggleChildren"></label>
        <!--<button @click="toggleChildren" v-if="has_chidren">tc</button>-->
        {{page.menutitle}}
      </div>
      <div class="td_price input-group" v-if="$route.name == 'FastEditUserPrice' && is_this_approved">
        <input type="text" :disabled="is_materials_selected" @input="material_price_old = true" v-model="material_price" :placeholder="base_material_price" @keyup.enter="updateField(material_price, 'material_price')" class="form-control">
        <div class="input-group-append" v-if="!is_materials_selected && material_price_old">
          <button class="btn btn-primary" @click="updateField(material_price, 'material_price')">Ок</button>
        </div>
      </div>
      <div class="td_phone input-group" v-if="$route.name == 'FastEditUserPrice' && is_this_approved">
        <input type="text" :disabled="is_materials_selected" @input="phone_old = true" v-model="phone" placeholder="Телефон" @keyup.enter="updateField(phone, 'phone')" class="form-control">
        <div class="input-group-append" v-if="!is_materials_selected && phone_old">
          <button class="btn btn-primary" @click="updateField(phone, 'phone')">Ок</button>
        </div>
      </div>
      <div class="td_email input-group" v-if="$route.name == 'FastEditUserPrice' && is_this_approved && email !== false">
        <input type="text" :disabled="is_materials_selected" @input="email_old = true" v-model="email" placeholder="Email" @keyup.enter="updateField(email, 'email')" class="form-control">
        <div class="input-group-append" v-if="!is_materials_selected && email_old">
          <button class="btn btn-primary" @click="updateField(email, 'email')">Ок</button>
        </div>
      </div>
      <!--<div class="td_stat">Статистика</div>-->
    </div>
    <div class="children" v-if="has_chidren && show_children">
      <!-- :m_val="child.id" -->
      <page-row
        v-for="(child, index) in page.children"
        :page="child"
        :key="index"
        :m_val="child"
        :level="level+1"
        :aproved_materials="aproved_materials"
        :active_city_id="active_city_id"
        :is_materials_selected="is_materials_selected"
        v-model="m_model"
        @updateField="updateField"
      ></page-row>
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return {
          materials_selected_comp: [],
          show_children:false,
          phone_old:false,
          email_old:false,
          material_price_old:false,
        }
    },
    computed:{
      is_this_approved:function(){
        return !!this.aproved_materials.filter(material => material.id == this.page.id).length;
      },
      classArray:function(){
        let result = [];
        result.push('level'+this.level);
        if(!this.is_this_approved && this.$route.name == 'FastEditUserPrice'){
          result.push('isnot_approved');
        }
        if(this.has_chidren){
          result.push('has_chidren');
        }
        return result;
      },
      has_chidren:function(){
        return !!this.page.children.length;
      },
      active_mic: function(){
        if(this.active_city_id){
          let mic = this.page.mic.filter(mic => mic.st_city_id == this.active_city_id);
          if(mic.length){
            return mic[0];
          }
        }
        return false;
      },
      material_price:{
        get: function(){
          let material_price = "";
          if(this.active_mic !== false && this.active_mic.st_material_price > 0){
            material_price = this.active_mic.st_material_price;
          }
          return material_price;
        },
        set: function(newVal){
          this.active_mic.st_material_price = newVal;
        },
      },
      base_material_price:function(){
        if(this.page.st_material_price > 0){
          return this.page.st_material_price+" р. / кг";
        }else{
          return "По запросу";
        }
      },
      phone:{
        get:function(){
          let tv_phone, phone;
          if(this.active_mic !== false){
            tv_phone = this.active_mic.tv.filter(tv => tv.name == "phone");
            if(tv_phone.length){
              phone = tv_phone[0].value;
            }
          }else{
            phone = "";
          }
          return phone;
        },
        set:function(newVal){
          let tv_phone, phone;
          if(this.active_mic !== false){
            tv_phone = this.active_mic.tv.filter(tv => tv.name == "phone");
            if(tv_phone.length){
              tv_phone[0].value = newVal;
            }
          }
        }
      },
      email: {
        get:function(){
          let tv_email, email;
          if(this.active_mic !== false){
            tv_email = this.active_mic.tv.filter(tv => tv.name == "email");
            if(tv_email.length){
              email = tv_email[0].value;
            }else{
              email = false;
            }
          }
          return email;
        },
        set:function(newVal){
          let tv_email, email;
          if(this.active_mic !== false){
            tv_email = this.active_mic.tv.filter(tv => tv.name == "email");
            if(tv_email.length){
              tv_email[0].value = newVal;
            }
          }
        }
      },
      m_model: {
        get() {
          return this.value;
        },
        set(newValue) {
          //console.log("set..");
          //this.onInput(newValue);
          this.$emit('input', newValue);
          //this.toggleChildren();

        },
      },
    },
    props: {
      page: Object,
      level: Number,
      active_city_id: Number,
      m_val: Object,
      value: Array,
      aproved_materials: Array,
      is_materials_selected: Boolean,
    },
    beforeCreate: function () {
      // для корректного рекурсивного использования компонента
      this.$options.components.PageRow = require('./PageRow.vue').default
    },
    methods:{
      toggleChildren: function(event){
        if(this.has_chidren){
          this.$nextTick(() => {
            let m_val = this.m_model;
            let m_children = [];
            //let m_children = this.page.children;
            m_children.push(...this.page.children);
            this.page.children.map(item => {
              if(item.children.length){
                m_children.push(...item.children);
              }
            });
            if(m_val.map(item => item.id).indexOf(this.page.id) !== -1){
              m_val.push(...m_children.filter(item => {
                if(m_val.map(itemX => itemX.id).indexOf(item.id) === -1){
                  return true;
                }
              }));
            }else if(m_val.map(item => item.id).indexOf(this.page.id) === -1){
              for(let item in m_children){
                m_val.splice(m_val.map(item => item.id).indexOf(m_children[item].id), 1);
              }
            }      
            this.$emit('input', m_val);
          });
        }
      },
      toggleShowChildren:function(){
        this.show_children = !this.show_children;
      },
      updateField: function(val, type){
        //console.log("val: "+ val);
        let data;
        if(typeof type === "undefined" && typeof val !== "string"){
          data = val;
        }else{
          data = {
            value: val,
            type: type,
            city_id: this.active_city_id,
            material_ids: [this.page.id],
          }
          this[type+'_old'] = false;
        }
        this.$emit('updateField', data);
      },
      setToChildren:function(){

      }
    },
  }
</script>
<style>
.page_row_item.isnot_approved >.td_row > .td_material{
  opacity: 0.6;
}
.td_material label{
  margin-bottom: 0;
}
.page_row_item{
  position: relative;
}
.page_row_item.level2 .td_material{
  margin-left: 1%;
  flex-basis: 39%;
}
.page_row_item.level3 .td_material{
  margin-left: 2%;
  flex-basis: 38%;
}
.page_row_item.level2 .td_price{
  margin-left: 0.5%;
  flex-basis: 19.5%;
}
.page_row_item.level2 .td_phone{
  margin-left: 0.5%;
  flex-basis: 19.5%;
}
.page_row_item.level2 .td_email{
  margin-left: 0.5%;
  flex-basis: 19.5%;
}
.page_row_item.level2 .td_stat{
  margin-left: 0.5%;
  flex-basis: 19.5%;
}
.page_row_item.level3 .td_price{
  margin-left: 1%;
  flex-basis: 19%;
}
.page_row_item.level3 .td_phone{
  margin-left: 1%;
  flex-basis: 19%;
}
.page_row_item.level3 .td_email{
  margin-left: 1%;
  flex-basis: 19%;
}
.page_row_item.level3 .td_stat{
  margin-left: 1%;
  flex-basis: 19%;
}
.show_children{
  position: absolute;
  left: -25px;
  cursor: pointer;
}
.show_children span {
	display: inline-block;
	border: 1px solid;
	border-radius: 3px;
	width: 16px;
	height: 16px;
	line-height: 12px;
	text-align: center;
	font-weight: bold;
	color: #555;
}
</style>
