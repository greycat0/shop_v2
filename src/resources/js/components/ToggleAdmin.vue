<template>
    
</template>

<script>
  export default {
    name: "Admin",
    props:{
      admin: false
    },
    mounted() {
      this.$store.state.isAdmin = this.admin
    }
  }
</script>

<style scoped>

</style>