import { Drawer, Button, Form, Input, Space, Row, Col, Switch } from "antd";
import React, { useEffect, useState } from "react";
import { useAddDepartmentMutation } from "../../services/departmentApi";


function NewDepartment({ showDrawer, handleClick, departmentData }) {
  const [addDepartment,{data:addedData,isError:saveError}] = useAddDepartmentMutation();
  const [updateDepartment, { data:updatedData, isError:updateError }] =
    useUpdateDepartmentMutation();

  const onFinish = async (department) => {
    if (departmentData !== null) {
      await updateDepartment(department);
    } else {
      await addDepartment(department);
    }
    handleClick();
  };

  const [form] = Form.useForm();
  if (departmentData !== null) {
    form.setFieldsValue({
      id: departmentData.id,
      name: departmentData.name,
      identifier: departmentData.identifier,
    });
  } else form.resetFields();

  const formRef = React.createRef();
  return (
    <Drawer
      title="Add New Department"
      width={500}
      visible={showDrawer}
      onClose={handleClick}
    >
      <Form layout="vertical" form={form} ref={formRef} onFinish={onFinish}>
        <Form.Item name="id" hidden>
          <Input />
        </Form.Item>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="name"
              label="Name"
              rules={[
                { required: true, message: "Please enter department name" },
              ]}
            >
              <Input placeholder="Please enter department name" />
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item name="identifier" label="Identifier"
            rules={[
              { required: true, message: "Please enter identifier" },
            ]}>
              <Input placeholder="Please enter identifier" />
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item name="interconnect" label="Interconnect">
                <Switch/>
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Space>
              <Button type="primary" htmlType="submit">
                Submit
              </Button>
              <Button onClick={handleClick}>Cancel</Button>
            </Space>
          </Col>
        </Row>
      </Form>
    </Drawer>
  );
}

export default NewDepartment;
