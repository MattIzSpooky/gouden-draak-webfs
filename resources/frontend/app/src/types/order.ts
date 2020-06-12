import {MenuItem, OrderedMenuItem} from '@/types/menu-item';
import {ApiResource} from '@/types/api';

export type NewOrderRequest = {
  id: number;
  paidAt: string | null;
  createdAt: string;
  tableId: number;
  items: ApiResource<MenuItem[]>;
}

export type Order = {
  id: number;
  createdAt: string;
  paidAt: string | null;
  items: OrderedMenuItem[];
}

export type OrderFilterRequest = {
  from: string;
  to: string;
}
