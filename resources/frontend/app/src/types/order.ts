import {MenuItemApiResource} from "@/types/menu-item";

export type OrderApiResource = {
  id: number;
  paid_at: string;
  created_at: string;
  items: MenuItemApiResource
}
