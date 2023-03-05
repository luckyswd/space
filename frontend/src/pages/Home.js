import {SmileOutlined} from '@ant-design/icons';
import {Result, Button} from 'antd';
import { Navigate, useNavigate } from 'react-router-dom';

import {auth} from "../api/auth";

export default () => {
  const navigate = useNavigate();

  if (!!auth.getToken()) {
    return (<Navigate to="/admin" />)
  }

  return (
    <Result
      icon={<SmileOutlined/>}
      title="Добро пожаловать!"
      extra={(
        <>
          <Button type="primary" onClick={() => navigate('/register')}>Зарегистрироваться</Button>
          <Button type="primary" onClick={() => navigate('/login')}>Войти</Button>
        </>
      )}
    />
  )
};