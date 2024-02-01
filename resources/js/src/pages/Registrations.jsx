import {
  DeleteOutlined,
  EditOutlined,
  EyeOutlined,
  PlusOutlined,
} from "@ant-design/icons";
import {
  Row,
  Col,
  Button,
  Space,
  Table,
  Popconfirm,
  Tag,
  Pagination,
} from "antd";
import React from "react";
import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useGetRegistrationsQuery } from "../services/registrationApi";

const Registrations = () => {
  const [page,setPage] = useState(1);
  const { data: registrations, isSuccess } = useGetRegistrationsQuery(page);
  const navigate = useNavigate();
  const columns = [
    {
      key: "registration_number",
      title: "Registration No.",
      dataIndex: "registration_number",
      width: "12%",
    },
    {
      title: "Registration Date",
      key: "registration_date",
      dataIndex: "registration_date",
      width: "15%",
    },
    {
      key: "subject",
      title: "Subject",
      dataIndex: "subject",
      width: "30%",
    },
    {
      key: "service",
      title: "Service",
      dataIndex: "service",
      width: "20%",
    },
    {
      key: "service",
      title: "Secrecy / Urgency",
      dataIndex: "service",
      width: "20%",
      render: (_, { secrecy, urgency }) => {
        return (
          <>
            <Tag color="blue" key={1}>
              {secrecy}
            </Tag>
            <Tag color="red" key={2}>
              {urgency}
            </Tag>
          </>
        );
      },
    },
    {
      title: "Action",
      dataIndex: "",
      key: "x",
      render: (registration) => (
        <Space>
          <Button
            type="success"
            onClick={() => navigate(`/registration_details/${registration.id}`)}
            icon={<EyeOutlined />}
          ></Button>
          {!registration.registration_number && (
            <Button type="primary" icon={<EditOutlined />}></Button>
          )}
          <Button type="danger" icon={<DeleteOutlined />}></Button>
        </Space>
      ),
    },
  ];
  const handleChange = (pagination,filters,sorter)=>
  {
      setPage(pagination);

  }
  return (
    <Space direction="vertical" size="middle" style={{ display: "flex" }}>
      <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
        <Col span={24} className="gutter-row">
          <Button
            type="primary"
            icon={<PlusOutlined />}
            onClick={() => navigate("/new_registration")}
          >
            Add New Registration
          </Button>
        </Col>
      </Row>
      <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
        <Col span={24} className="gutter-row">
          <Table
            dataSource={isSuccess && registrations.data}
            columns={columns}
            pagination={{
              pageSize:10,
              total:isSuccess && registrations.meta.total,
              onChange:handleChange
            }}
          />
        </Col>
      </Row>
      
    </Space>
  );
};

export default Registrations;
