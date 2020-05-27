<template>
  <table style="margin:auto;font-size:20px;color:white" border="1px solid white">
    <!-- TODO: fix this garbage -->
    <tr :style="{'background-image': 'url(' + require('../../assets/images/menu_bg_gradient.png') + ')'}">
      <td valign="middle">
        <router-link class="page-link" to="/menu">Menukaart</router-link>
      </td>
      <td valign="middle">
        <router-link class="page-link" to="/news">Nieuws</router-link>
      </td>
      <td valign="middle">
        <router-link class="page-link" to="/contact">Contact</router-link>
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  name: 'PageLinks'
};
</script>

<style lang="scss">
 .page-link {
   display: inline-block;
   color: white;
   width: 177px;
 }
</style>
