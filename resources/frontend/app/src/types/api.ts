export type ApiResource<T> = {
  data: T;
}

export type ApiValidationError<TRequest> = {
  message: string;
  errors: { [key in keyof TRequest]?: string[] };
}
