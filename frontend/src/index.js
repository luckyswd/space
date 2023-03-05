import React from 'react';
import {Provider} from 'react-redux'
import store from './store'
import ReactDOM from 'react-dom/client';
import {
  RouterProvider,
} from "react-router-dom";
import 'antd/dist/reset.css';
import './index.css';
import index from "./router";
import * as serviceWorkerRegistration from './serviceWorkerRegistration';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <Provider store={store}>
      <RouterProvider router={index}/>
    </Provider>
  </React.StrictMode>
);

serviceWorkerRegistration.register();