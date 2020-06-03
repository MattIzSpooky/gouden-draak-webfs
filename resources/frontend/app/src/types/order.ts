import {MenuItemApiResource} from "@/types/menu-item";

export type OrderApiResource = {
  id: number;
  paidAt: string;
  createdAt: string;
  items: MenuItemApiResource
}
