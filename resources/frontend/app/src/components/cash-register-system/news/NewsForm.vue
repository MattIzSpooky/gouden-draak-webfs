<template>
  <div>
    <div class="alert alert-danger" role="alert" v-if="error && error.message">
      {{error.message}}
    </div>
    <form action="#" @submit.prevent="emitForm">
      <div class="form-group">
        <label for="title">Titel</label>
        <input type="text" required v-model="formData.title" class="form-control" id="title"
               :class="{'is-invalid': error && error.errors.title}">
        <div v-if="error && error.errors.title">
          <p v-for="error in error.error.title" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label for="text">Beschrijving</label>
        <textarea class="form-control" required v-model="formData.text" id="text" rows="3"
                  :class="{'is-invalid': error && error.errors.text}"></textarea>
        <div v-if="error && error.errors.text">
          <p v-for="error in error.error.text" :key="error" class="text-danger">
            {{error}}
          </p>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Opslaan</button>
      <slot></slot>
    </form>
  </div>
</template>

<script lang="ts">
import {Component, Emit, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';
import {NewsRequest} from '@/types/news';

  @Component
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
