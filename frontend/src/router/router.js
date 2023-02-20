import {
  createBrowserRouter,
} from "react-router-dom";

import App, {loader} from "../App";
import Login from "../pages/auth/Login";
import Error from "../pages/Error";
import Register from "../pages/auth/Register";

const router = createBrowserRouter([
  {
    path: "/",
    element: <App />,
    loader: loader,
    children: [

    ],
    errorElement: <Error />
  },
  {
    path: '/register',
    element: <Register/>
  },
  {
    path: 'login',
    element: <Login/>
  },
]);

export default router;

