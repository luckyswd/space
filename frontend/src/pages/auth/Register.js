import {
  Button,
  Form,
  Input,
  Checkbox,
  Row,
  Col
} from "antd";

const Login = () => {
  const onFinish = () => {
    console.log('register')
  }

  return (
    <Row justify="center" align="middle" style={{ height: '100%' }}>
      <Col>
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
            <Input/>
          </Form.Item>

          <Form.Item
            label="Password"
            name="password"
            rules={[
              {
                required: true,
                message: 'Пожалуйста, введите ваш пароль!',
              },
            ]}
          >
            <Input.Password/>
          </Form.Item>

          <Form.Item
            name="remember"
            valuePropName="checked"
            wrapperCol={{
              sm: {
                offset: 8,
                span: 16,
              }
            }}
          >
            <Checkbox>Remember me</Checkbox>
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
