import React from "react";
import { Drawer, Button, Form, Input, Space, Row, Col } from "antd";
import { useState } from "react";

const UpdateFile = () => {
  const [file, setFile] = useState();
  return (
    <Drawer
      title="Update File"
      width={500}
      visible={showDrawer}
      onClose={handleClick}
    >
      <Form layout="vertical" ref={formRef} onFinish={onFinish}>
        <Form.Item name="id" hidden>
          <Input />
        </Form.Item>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="file"
              label="File"
              rules={[{ required: true, message: "Please select file" }]}
            >
              <Input
                type={file}
                onChange={(e) => setFile(e.target.files)}
                placeholder="Please select file"
              />
            </Form.Item>
          </Col>
        </Row>
        <Row gutter={16}>
          <Col span={24}>
            <Form.Item
              name="file_name"
              label="File Name"
              rules={[{ required: true, message: "Please enter filename" }]}
            >
              <Input placeholder="Please enter filename" />
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
};

export default UpdateFile;
