import {
  createBrowserRouter,
} from "react-router-dom";

import App from "../App";
import Login from "../pages/auth/Login";
import Error from "../pages/Error";
import Register from "../pages/auth/Register";
import ProtectedRoute from "./ProtectedRoute";
import Home from "../pages/Home";
import UserList from "../components/UserList";

export default createBrowserRouter([
  {
    path: "/",
    element: (<Home />),
    errorElement: <Error />
  },
  {
    path: 'admin',
    element: (<ProtectedRoute><App/></ProtectedRoute>),
    children: [
      {
        path: 'users',
        element: <UserList />
      },
    ]
  },
  {
    path: 'register',
    element: <Register/>
  },
  {
    path: 'login',
    element: <Login/>
  },
]);