import {MenuItem} from '@/types/menu-item';
import {ApiResource} from '@/types/api';

export type NewOrderRequest = {
  id: number;
  paidAt: string | null;
  createdAt: string;
  items: ApiResource<MenuItem[]>;
}
