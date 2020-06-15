<template>
  <base-form-input :error="error" :id="id" :name="name">
    <template v-slot:input>
      <textarea class="form-control" required v-model="internalValue" :id="id" :rows="rows"
                :class="{'is-invalid': error && error.errors[id]}"></textarea>
    </template>
    <template v-slot:action>
      <slot name="action"/>
    </template>
  </base-form-input>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue, Watch} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import BaseFormInput from '@/components/cash-register-system/common/forms/BaseFormInput.vue';

  @Component({
    components: {
      BaseFormInput
    }
  })
export default class FormTextarea extends Vue {
    @Prop({
      required: true
    }) public value!: string;

    @Prop({
      required: true,
      type: String
    }) public name!: string;

    @Prop({
      required: true,
      type: String
    }) public id!: string;

    @Prop({
      required: false,
      default: '3',
      type: String
    }) public rows!: string;

    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<unknown>;

    @Watch('internalValue')
    @Emit('input')
    valueChanged() {
      return this.internalValue;
    }

    @Watch('value', {immediate: true})
    externalValueChanged() {
      this.internalValue = this.value;
    }

    private internalValue = '';

    created() {
      this.internalValue = this.value;
    }
}
</script>
