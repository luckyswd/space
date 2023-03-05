import {createAsyncThunk} from "@reduxjs/toolkit";

export const fetchClients = createAsyncThunk(
  'todos/fetchClients',
  async (_, {rejectWithValue}) => {
    try {
      const response = await fetch('https://jsonplaceholder.typicode.com/posts/1/comments')
      if (!response.ok) {
        throw new Error('Server error')
      }
      return await response.json()
    } catch (error) {
      return rejectWithValue(error.message)
    }
  }
);