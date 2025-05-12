export interface Post {
  id: number;
  name: string;
  text: string;
  created_at: string;
  updated_at: string;
  editable?: boolean;
  image_url?: string;
}
