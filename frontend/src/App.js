import React, {useCallback, useEffect} from 'react';
import {Layout, theme, Avatar, Col, Row, Dropdown, Menu} from 'antd';
import {UserOutlined, LogoutOutlined, ProfileOutlined} from '@ant-design/icons';
import {useDispatch} from "react-redux";
import {fetchClients} from "./store/clients/thunks";
import Sidebar from "./modules/sidebar/Sidebar";
import {Link, useNavigate, Outlet} from "react-router-dom";
import {auth} from "./api/auth";

const {Header, Content, Footer} = Layout;
const App = () => {
  const dispatch = useDispatch()
  const navigate = useNavigate();

  useEffect(() => {
    dispatch(fetchClients())
  }, [])

  const logout = useCallback(() => {
    auth.logout()
      .then(() => navigate('/'))

  }, [])

  const {
    token: {colorBgContainer},
  } = theme.useToken();
  return (
    <Layout style={{height: '100%'}}>
      <Sidebar/>
      <Layout>
        <Header
          style={{
            padding: '0 15px',
            background: colorBgContainer,
          }}
        >
          <Row justify="end">

            <Col span={'auto'}>

              <Dropdown
                placement="bottomLeft"
                overlay={
                  <Menu
                    items={[
                      {
                        key: '1',
                        label: 'Профиль',
                        icon: <ProfileOutlined/>,
                        disabled: true,
                      },
                      {
                        key: '3',
                        label: (<Link onClick={logout}>Выйти</Link>),
                        icon: <LogoutOutlined/>,
                        danger: true,

                      },
                    ]}
                  />
                }
                trigger={['click']}
              >
                <Avatar size={45} icon={<UserOutlined style={{}}/>}/>
              </Dropdown>
            </Col>


          </Row>
        </Header>
        <Content
          style={{
            margin: '24px 15px 0',
          }}
        >
          <div
            style={{
              padding: 24,
              minHeight: 360,
              background: colorBgContainer,
              height: '100%'
            }}
          >
            <Outlet/>
          </div>
        </Content>
        <Footer
          style={{
            textAlign: 'center',
          }}
        >
          Space ©2023
        </Footer>
      </Layout>
    </Layout>
  );
};

export default App;
