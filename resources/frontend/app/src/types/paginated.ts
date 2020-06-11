export type Paginated<T> = {
  data: T[];
  links: PaginatedLinks;
  meta: PaginationMetaData;
}

export type PaginatedLinks = {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
}

export type PaginationMetaData = {
  current_page: number;
  from: number;
  last_page: number;
  path: string;
  per_page: number;
  total: number;
}
