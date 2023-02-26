import {
  Button,
  Form,
  Input,
  Checkbox,
  Row,
  Col
} from "antd";

import {auth} from "../../api/auth";
import {useEffect, useState, useRef} from "react";
import {useNavigate} from "react-router-dom";
import Title from "antd/es/typography/Title";

const Login = () => {
  const [credentials, setCredentials] = useState({
    email: '',
    password: ''
  });
  const emailRef = useRef();
  const navigate = useNavigate();

  const handleInputForm = (name, value) => {
    setCredentials({...credentials, [name]: value})
  }

  useEffect(() => {
    emailRef.current?.focus()
  }, [])

  const onFinish = () => {
    auth.register(credentials).then(r => {
      navigate('/login')
    })
  }

  return (
    <Row justify="center" align="middle" style={{height: '100%'}}>
      <Col>
        <Title style={{textAlign: 'center', marginBottom: '30px'}}>Регистрация</Title>

        <Form
          name="basic"
          labelCol={{
            span: 8,
          }}
          wrapperCol={{
            span: 16,
          }}
          style={{
            maxWidth: 600,
          }}
          initialValues={{
            remember: true,
          }}
          onFinish={onFinish}
          autoComplete="off"
        >

          <Form.Item
            label="Email"
            name="email"
            rules={[
              {
                required: true,
                message: 'Пожалуйста, введите ваш @',
              },
            ]}
          >
            <Input ref={emailRef} onChange={(e) => handleInputForm('email', e.target.value)} value={credentials.email}/>
          </Form.Item>

          <Form.Item
            label="Пароль"
            name="password"
            rules={[
              {
                required: true,
                message: 'Пожалуйста, введите ваш пароль!',
              },
            ]}

          >
            <Input.Password onChange={(e) => handleInputForm('password', e.target.value)} value={credentials.password}/>
          </Form.Item>

          <Form.Item
            wrapperCol={{
              sm: {
                offset: 8,
                span: 16,
              }
            }}
          >
            <Button type="primary" htmlType="submit">
              Submit
            </Button>
          </Form.Item>
        </Form>
      </Col>
    </Row>
  );
}

export default Login;
