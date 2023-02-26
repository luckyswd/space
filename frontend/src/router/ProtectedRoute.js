import {Navigate} from 'react-router-dom';
import {auth} from "../api/auth";

export default ({children}) => {

  if (!auth.hasJwt()) {
    return <Navigate to="/" replace/>;
  }

  return children;
}