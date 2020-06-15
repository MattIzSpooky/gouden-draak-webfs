<template>
  <div class="form-group">
    <label :for="id">{{name}}</label>
    <slot name="input"/>
    <div v-if="error && error.errors[id]">
      <p v-for="error in error.error[id]" :key="error" class="text-danger">
        {{error}}
      </p>
    </div>
    <slot name="action"/>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import BaseFormInput from '@/components/cash-register-system/common/forms/BaseFormInput.vue';
  @Component({
    components: {BaseFormInput}
  })
export default class FormSelect extends Vue {
    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<unknown>;

    @Prop({
      required: true,
      type: String
    }) public name!: string;

    @Prop({
      required: true,
      type: String
    }) public id!: string;
}
</script>

<style scoped>

</style>
