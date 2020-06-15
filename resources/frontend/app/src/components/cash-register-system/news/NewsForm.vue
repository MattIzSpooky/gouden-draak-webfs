<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="emitForm">
      <form-input name="Titel" id="title" v-model="formData.title" :error="error"/>
      <form-textarea name="Beschrijving" id="text" v-model="formData.text"/>
      <button type="submit" class="btn btn-primary">Opslaan</button>
      <slot></slot>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import {NewsRequest} from '@/types/news';
import FormInput from '@/components/cash-register-system/common/forms/FormInput.vue';
import FormTextarea from '@/components/cash-register-system/common/forms/FormTextarea.vue';
@Component({
  components: {FormTextarea, FormInput}
})
export default class NewsForm extends Vue {
    @Prop({
      type: Object
    }) public readonly error!: ApiValidationError<NewsRequest>;

    @Prop({
      default: () => ({
        title: '',
        text: ''
      }),
      type: Object
    }) private readonly formData!: NewsRequest;

    @Emit('onSubmit')
    emitForm(): NewsRequest {
      return this.formData;
    }
};
</script>
