<template>
  <div id="app">
    <hashpass></hashpass>
  </div>
</template>

<script>
  import Hashpass from './components/Hashpass.vue'

  export default {
    name: 'app',
    components: {
      Hashpass
    }
  }
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
</style>
