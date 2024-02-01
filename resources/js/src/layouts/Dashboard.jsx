import { Layout } from "antd";
import React, { useState } from "react";
import { MenuFoldOutlined, MenuUnfoldOutlined } from "@ant-design/icons";
import { Route, Routes } from "react-router-dom";
import Registrations from "../pages/Registrations";
import Provinces from "../pages/Provinces";
import DashboardHeader from "./Header";
import Sidebar from "./Sidebar";
import Districts from "../pages/Districts";
import Privileges from "../pages/Privileges";
import Departments from "../pages/Departments";
import NewRegistration from "../pages/drawers/NewRegistration";
import AssignDocument from "../pages/drawers/AssignDocument";
import RegistrationDetails from "../pages/RegistrationDetails";
import ViewFile from "../components/ViewFile";
import Documents from "../pages/Documents";
import Document from "../pages/Document";
import InvoiceDetails from "../pages/InvoiceDetails";
import Invoices from "../pages/Invoices";
import AllNotifications from "../pages/AllNotifications";

let { Header, Sider, Content } = Layout;

function Dashboard() {
  const [collapsed, setCollapsed] = useState(false);
  return (
    <>
      <Layout style={{ minHeight: "100vh" }}>
        <Sider trigger={null} collapsible collapsed={collapsed}>
          <Sidebar />
        </Sider>
        <Layout className="site-layout">
          <Header className="site-layout-background" style={{ padding: 0 }}>
            {collapsed ? (
              <MenuUnfoldOutlined
                className="trigger"
                onClick={() => setCollapsed(!collapsed)}
              />
            ) : (
              <MenuFoldOutlined
                className="trigger"
                onClick={() => setCollapsed(!collapsed)}
              />
            )}
            <DashboardHeader />
          </Header>
          <Content
            className="site-layout-background"
            style={{
              margin: "24px 16px",
              padding: 24,
              minHeight: 280,
            }}
          >
            <Routes>
              <Route path="/" element={<Registrations />} />
              <Route path="/registrations" element={<Registrations />} />
              <Route path="/invoices" element={<Invoices />} />
              <Route path="/provinces" element={<Provinces />} />
              <Route path="/districts" element={<Districts />} />
              <Route path="/privileges" element={<Privileges />} />
              <Route path="/departments" element={<Departments />} />
              <Route path="/documents" element={<Documents />} />
              <Route path="/new_registration" element={<NewRegistration />} />
              <Route
                exact
                path="/registration_details/:registration_id"
                element={<RegistrationDetails />}
              />
              <Route
                exact
                path="/invoice_details/:invoice_id"
                element={<InvoiceDetails />}
              />
              <Route
                path="/assign_document/:registration_id"
                element={<AssignDocument />}
              />
              <Route path="/document/file/:file_id" element={<ViewFile />} />
              <Route path="/document/:document_id" element={<Document />} />
              <Route path="/notifications/all" element={<AllNotifications />} />
            </Routes>
          </Content>
        </Layout>
      </Layout>
    </>
  );
}

export default Dashboard;
