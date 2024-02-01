import {
  DeleteColumnOutlined,
  DeleteOutlined,
  EditOutlined,
} from "@ant-design/icons";
import { Button, Col, PageHeader, Popconfirm, Row, Space, Table } from "antd";
import React from "react";
import { useAddDepartmentMutation, useDeleteDepartmentMutation, useGetAllDepartmentQuery } from "../services/departmentApi";

const Departments = () => {
  const { data: allDepartment, isSuccess } = useGetAllDepartmentQuery();

  const [deleteDepartment,{data,isError}] = useDeleteDepartmentMutation();

  const confirm = (department_id)=>{
    deleteDepartment(department_id)
  }
  const columns = [
    {
      title: "Name",
      dataIndex: "name",
      key: "name",
    },
    {
      title: "Interconnect",
      key: "interconnect",
      render: (department) => {
        return department.interconnect === 1 ? "Yes" : "No";
      },
    },
    {
      title: "Action",
      dataIndex: "",
      key: "x",
      render: (department) => (
        <Space>
          <Button type="primary" icon={<EditOutlined />}></Button>
          <Popconfirm
            title="Are you sure delete this record?"
            onConfirm={() => confirm(department.id)}
            okText="Yes"
            cancelText="No"
          >
            <Button type="danger" icon={<DeleteOutlined />}></Button>
          </Popconfirm>
        </Space>
      ),
    },
  ];
  return (
    <Space direction="vertical" style={{ display: "flex" }} size="middle">
      <PageHeader title="Departments" />
      <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
        <Col span={24}>
          <Table dataSource={allDepartment} columns={columns} />
        </Col>
      </Row>
    </Space>
  );
};

export default Departments;
