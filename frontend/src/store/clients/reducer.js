import {createSlice} from "@reduxjs/toolkit";
import {fetchClients} from "./thunks";

const clientSlice = createSlice({
  name: 'clients',
  initialState: {
    clients: [],
    status: null,
    error: null,
  },
  reducers: {
    addClient(state, action) {
      state.clients.push({
        id: Date.now().toString(),
        text: action.payload,
      })
    },
    removeClient(state, action) {},
  },
  extraReducers: {
    [fetchClients.fulfilled]: (state, action) => {
      state.status = 'resolved';
      state.error = null;
    },
    [fetchClients.fulfilled]: (state, action) => {
      state.status = 'resolved';
      state.clients = action.payload
    },
    [fetchClients.rejected]: (state, action) => {
      state.status = 'resolved';
      state.error = action.payload
    }
  }
})

export const {
  addClient,
  removeClient
} = clientSlice.actions

export default clientSlice.reducer