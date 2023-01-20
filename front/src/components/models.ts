export interface Todo {
  id: number
  content: string
}

export interface Meta {
  totalCount: number
}

export interface Shop {
  id: number
  avatar: string
  type: string
  name: string
  address: string
  city: string
  phone: string
  email: string
  document: string
  status: string
  user_id: number
}

export interface Category {
  id?: number
  name: string
  shop_id: number
}
