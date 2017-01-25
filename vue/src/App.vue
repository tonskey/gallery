<template>
    <div id="app">
        <h></h> 
        <div id="main" class="container-fluid">
            <router-view></router-view>
        </div>
        <f></f>
    </div>
</template>
<script>
    export default {
        name: 'app',
        components: {
            h:require('./components/template/header.vue'),
            f:require('./components/template/footer.vue')
        },
        created(){
            this.$store.dispatch('checkAuth');
        }
    }
</script>
<style type="text/css">
    #main{
        min-height: 500px;
        margin-top: 70px;
    }
</style>
