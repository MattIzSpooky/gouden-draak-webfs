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
import {Component} from 'vue-property-decorator';
import {mixins} from 'vue-class-component';
import {FormInputMixin} from '@/mixins/FormInput';

  @Component
export default class BaseFormInput extends mixins(FormInputMixin) {
}
</script>
