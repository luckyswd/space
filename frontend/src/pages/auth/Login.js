import {Button, Form, Input, Checkbox, Row, Col} from "antd";
import {auth} from "../../api/auth";
import {useEffect, useRef, useState} from "react";
import {useNavigate} from "react-router-dom";
import Title from "antd/es/typography/Title";


const Login = () => {
  const [credentials, setCredentials] = useState({
    username: '',
    password: '',
  })
  const navigate = useNavigate();
  const emailRef = useRef();

  const handleInputForm = (name, value) => {
    setCredentials({...credentials, [name]: value})
  }

  useEffect(() => {
    emailRef.current?.focus()
  }, [])

  const onFinish = () => {
    auth.login(credentials).then(res => {
      navigate('/admin')
    })
  }

  return (
    <>
      <Row justify="center" align="middle" style={{ height: '100%' }}>
        <Col>
          <Title style={{textAlign: 'center', marginBottom: '30px' }}>Войти</Title>
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
              <Input ref={emailRef} onChange={(e) => handleInputForm('username', e.target.value)} value={credentials.username}/>

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
              <Input.Password onChange={(e) => handleInputForm('password', e.target.value)} value={credentials.password} />
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
    </>
  );
}

export default Login;
