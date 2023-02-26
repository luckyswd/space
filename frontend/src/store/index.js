import {configureStore} from "@reduxjs/toolkit";
import clientReducer from './clients/reducer'

export default configureStore({
  reducer: {
    clients: clientReducer,
  },
  devTools: process.env.NODE_ENV !== 'production',
})