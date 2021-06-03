<template>
  <span class="botones" @click='queryChange()'>{{this.$root.test}}</span>
</template>

<script>
export default {
    props:['text'],
    data(){
        return{
            
        }
    },
    methods:{
        queryChange(){
            return this.$root.test = "Más popus";
        }
    }
}
</script>

<style>

</style>