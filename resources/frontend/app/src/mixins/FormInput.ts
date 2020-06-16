import Component from 'vue-class-component';
import Vue from 'vue';
import {Emit, Prop, Watch} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';

@Component
export class FormInputMixin extends Vue {
  @Prop({
    required: false
  }) public value!: unknown;

  @Prop({
    required: true,
    type: String
  }) public name!: string;

  @Prop({
    required: true,
    type: String
  }) public id!: string;

  @Prop({
    required: true
  }) public error!: ApiValidationError<never>;

  @Prop({
    default: false
  }) public required!: boolean;

  @Watch('internalValue')
  @Emit('input')
  internalValueChanged() {
    return this.internalValue;
  }

  @Watch('value', {immediate: true})
  externalValueChanged() {
    // eslint-disable-next-line
    this.internalValue = this.value as any;
  }

  private internalValue = null;

  created() {
    // eslint-disable-next-line
    this.internalValue = this.value as any;
  }
}
