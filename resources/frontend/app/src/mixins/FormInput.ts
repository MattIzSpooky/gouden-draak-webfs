import Component from 'vue-class-component';
import Vue from 'vue';
import {Emit, Prop, Watch} from 'vue-property-decorator';

@Component
export class FormInputMixin extends Vue {
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

  @Watch('internalValue')
  @Emit('input')
  internalValueChanged() {
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
