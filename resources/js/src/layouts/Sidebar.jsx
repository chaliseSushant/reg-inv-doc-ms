import {
  EditOutlined,
  RightCircleOutlined,
  SendOutlined,
} from "@ant-design/icons";
import { Menu } from "antd";
import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { useLocation, useNavigate } from "react-router";

function Sidebar() {
  const location = useLocation();
  const navigate = useNavigate();
  const menus = [
    {
      key: "1",
      label: "Registrations",
      icon: <EditOutlined />,
      path: "/registrations",
    },
    {
      key: "2",
      label: "Invoices",
      icon: <SendOutlined />,
      path: "/invoices",
    },
    {
      key: "3",
      label: "Documents",
      icon: <RightCircleOutlined />,
      path: "/documents",
    },
    {
      key: "4",
      label: "Provinces",
      icon: <RightCircleOutlined />,
      path: "/provinces",
    },
    {
      key: "5",
      label: "Districts",
      icon: <RightCircleOutlined />,
      path: "/districts",
    },
    {
      key: "6",
      label: "Privileges",
      icon: <RightCircleOutlined />,
      path: "/privileges",
    },
    {
      key: "7",
      label: "Departments",
      icon: <RightCircleOutlined />,
      path: "/departments",
    },
  ];

  const [selectedKey, setSelectedKey] = useState(location.pathname);

  const onClickMenu = (item) => {
    const clicked = menus.find((_item) => _item.key === item.key);
    navigate(clicked.path);
  };
  useEffect(() => {
    setSelectedKey(location.pathname);
  }, [location]);
  return (
    <>
      <div className="logo" />

      <Menu theme="dark">
        {menus.map((item) => {
          return (
            <Menu.Item
              icon={item.icon}
              key={item.key}
              onClick={onClickMenu}
              selectedKeys={[selectedKey]}
              defaultSelectedKeys={[selectedKey]}
            >
              {item.label}
            </Menu.Item>
          );
        })}
      </Menu>
    </>
  );
}

export default Sidebar;
//selectedKeys={[selectedKey]}
