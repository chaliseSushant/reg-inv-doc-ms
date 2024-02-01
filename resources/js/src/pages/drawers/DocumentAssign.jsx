import React, { useState, useEffect } from "react";
import {
  Drawer,
  message,
  Form,
  Row,
  Col,
  Radio,
  Select,
  Button,
  Input,
} from "antd";
import { useGetDepartmentListQuery } from "../../services/departmentApi";
import { useAssignDocumentMutation } from "../../services/registrationApi";
import { useGetUsersQuery } from "../../services/userApi";
import { useNavigate } from "react-router";

const DocumentAssign = ({ showDrawer, handleClick, registration_id }) => {
  const [assignDocument, { data: assignData, isSuccess, isError }] =
    useAssignDocumentMutation();
  const [value, setValue] = useState("department");
  const { data: allDepartments, isSuccess: getDepartmentsSuccess } =
    useGetDepartmentListQuery();
  const { data: allUsers } = useGetUsersQuery();
  const [lists, setLists] = useState([]);
  const navigate = useNavigate();
  const { TextArea } = Input;

  useEffect(() => {
    if (isSuccess) {
      message.success(assignData.success);
      navigate("/registrations");
    }
  }, [assignData]);
  useEffect(() => {
    getDepartmentsSuccess && setLists(allDepartments);
  }, [getDepartmentsSuccess]);
  const formRef = React.createRef();

  const onFinish = (values) => {
    values = { ...values, registration_id };
    assignDocument(values);
  };

  const onChangeRadio = (e) => {
    setValue(e.target.value);
    if (value === "department") {
      setLists(allUsers);
    } else {
      setLists(allDepartments);
    }
  };
  return (
    <>
      <Drawer
        title="Assign Document"
        width={500}
        visible={showDrawer}
        onClose={handleClick}
      >
        <Form layout="vertical" ref={formRef} onFinish={onFinish}>
          <Row gutter={16}>
            <Col span={12}>
              <Form.Item
                label="Assign Type"
                name="assign_type"
                initialValue="department"
              >
                <Radio.Group onChange={onChangeRadio} value={value}>
                  <Radio value="department">Department</Radio>
                  <Radio value="user">User</Radio>
                </Radio.Group>
              </Form.Item>
            </Col>
            <Col span={12}>
              <Form.Item label="Assign To" name="assign_id">
                <Select placeholder="Select Assignee . . .">
                  {lists.map((list) => {
                    return (
                      <Select.Option key={list.id} value={list.id}>
                        {list.name}
                      </Select.Option>
                    );
                  })}
                </Select>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item name="assign_remarks" label="Remarks">
                <TextArea rows={5}></TextArea>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Form.Item name="transfer_type" initialValue="forward_only">
                <Radio.Group>
                  <Radio value="forward_only">Forward Only</Radio>
                  <Radio value="approve">Approve</Radio>
                  <Radio value="disapprove">Disapprove</Radio>
                </Radio.Group>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={16}>
            <Col span={24}>
              <Button type="primary" htmlType="submit">
                Assign
              </Button>
            </Col>
          </Row>
        </Form>
      </Drawer>
    </>
  );
};

export default DocumentAssign;
