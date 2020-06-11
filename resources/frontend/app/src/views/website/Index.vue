<template>
  <dragon-page>
    <router-view/>
  </dragon-page>
</template>

<script>
import DragonPage from '../../components/website/DragonPage';

export default {
  name: 'Index',
  components: {DragonPage}
};
</script>

<style scoped>
  @import "../../styles/website.scss";
</style>
