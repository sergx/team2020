<template>
  <label :class="label_class">
    <input :class="input_class" :type="type" v-model="model" :value="val">
    <span><slot></slot></span>
  </label>
</template>
<script>
  export default {
    computed: {
      model: {
        get() {
          return this.value;
        },
        set(val) {
          this.$emit('input', val);
        },
      },
      input_class:function(){
        if(this.css_style){
          return this.css_style.input_class; 
        }else{
          return "";
        }
      },
      label_class:function(){
        if(this.css_style){
          if(this.type == "radio" && this.css_style.label_class_active){
            if(this.value && this.value == this.val){
              return this.css_style.label_class_active;
            }
          }
          if(this.css_style.label_class){
            return this.css_style.label_class;
          }
        }
        return "";
        // if(this.value.map(elem => elem.id).indexOf(this.val)){
        //   return this.label_class+" active";
        // }else{
        //   return this.label_class;
        // }
      }
    },
    props: [
      'value',
      'val',
      'type',
      'css_style',
    ]
  }
</script>
