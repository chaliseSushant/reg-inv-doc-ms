import { ControlOutlined } from "@ant-design/icons";
import { Drawer, Button, Form, Input, Space, Row, Col } from "antd";
import React, { useEffect, useState } from "react";
import {
  useAddProvinceMutation,
  useUpdateProvinceMutation,
} from "../../services/provinceApi";

function NewProvince({ showDrawer, handleClick, provinceData }) {
  const [addProvince] = useAddProvinceMutation();
  const [updateProvince, { isLoading, isError, error, isSuccess }] =
    useUpdateProvinceMutation();

  const onFinish = async (province) => {
    if (provinceData !== null) {
      updateProvince(province);
    } else {
      await addProvince(province);
    }
    handleClick();
  };

  const [form] = Form.useForm();
  if (provinceData !== null) {
    form.setFieldsValue({
      id: provinceData.id,
      name: provinceData.name,
      identifier: provinceData.identifier,
    });
  } else form.resetFields();

  const formRef = React.createRef();
  return (
    <Drawer
      title="Add New Province"
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
                { required: true, message: "Please enter province name" },
              ]}
            >
              <Input placeholder="Please enter province name" />
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

export default NewProvince;
