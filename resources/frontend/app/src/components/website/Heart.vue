<template>
  <span class="heart"></span>
</template>

<script>
export default {
  name: 'Heart'
};
</script>

<style scoped lang="scss">
  .heart {
    background-color: red;
    display: inline-block;
    height: 30px;
    margin: 0 10px;
    position: relative;
    top: 0;
    transform: rotate(-45deg);
    width: 30px;

    &:before,
    &:after {
       content: "";
       background-color: red;
       border-radius: 50%;
       height: 30px;
       position: absolute;
       width: 30px;
     }

    &:before {
      top: -15px;
      left: 0;
    }

    &:after {
      left: 15px;
      top: 0;
    }
  }
</style>
