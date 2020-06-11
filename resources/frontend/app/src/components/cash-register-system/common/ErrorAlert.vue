<template>
  <div class="alert alert-danger" role="alert">
    <h3>{{error.message}}</h3>
    <div class="mt-2" v-for="(error, name) in error.errors" :key="name">
      {{name}}
      <ul>
        <li v-for="(messages, index) in error" :key="index">
          {{messages}}
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import {Component, Prop, Vue} from 'vue-property-decorator';
import {ApiValidationError} from '@/types/api';

@Component
export default class ErrorAlert extends Vue {
   @Prop() public error!: ApiValidationError<never>;
};
</script>
