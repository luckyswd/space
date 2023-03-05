import React from "react";
import { Layout } from 'antd';

import logo from '../../assets/images/logo.svg'
import {Link} from "react-router-dom";
import SidebarMenu from "./SidebarMenu";
const { Sider } = Layout;

export default () => {
  return (
    <Sider
      breakpoint="lg"
      collapsedWidth="0"
    >
      <div className="logo">
        <Link to="/">
          <img src={logo} alt="logotype" style={{width: '100%'}}/>
        </Link>
        <SidebarMenu/>
      </div>
    </Sider>
  )
}