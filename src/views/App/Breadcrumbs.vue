<template>
  <nav class="breadcrumb is-small" aria-label="breadcrumbs">
    <ul>
      <li v-for="rl in cBreadcrumbs" v-bind:key="rl.key">
        <a href="#">{{rl}}</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "Breadcrumbs",
  computed:{
    cBreadcrumbs(){
      let a=["Home"];
      let b=this.$route.matched[0];  //checks the first matched route (!)
      let c=b.path.split("/");

      c.forEach(function(item){
        if (item.length>0) {
            a.push(item)
        }
      });
      return a;
    }
  }
}
</script>

<style scoped>

</style>