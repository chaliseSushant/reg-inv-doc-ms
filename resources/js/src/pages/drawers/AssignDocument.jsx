import {
  Button,
  Col,
  Form,
  Input,
  PageHeader,
  Radio,
  Row,
  Select,
  Space,
  message,
} from "antd";
import TextArea from "antd/lib/input/TextArea";
import React, { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router";
import { useGetDepartmentListQuery } from "../../services/departmentApi";
import { useAssignDocumentMutation } from "../../services/registrationApi";
import { useGetUsersQuery } from "../../services/userApi";

const AssignDocument = () => {
  let { registration_id } = useParams();
  const [assignDocument, { data: assignData, isSuccess, isError }] =
    useAssignDocumentMutation();
  const [value, setValue] = useState("department");
  const { data: allDepartments, isSuccess: getDepartmentsSuccess } =
  useGetDepartmentListQuery();
  const { data: allUsers} = useGetUsersQuery();
  const [lists, setLists] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    
    if (isSuccess) {
      message.success(assignData.success);
      navigate("/registrations");
    }
  }, [assignData]);
  useEffect(()=>{
    getDepartmentsSuccess && setLists(allDepartments);
  },[getDepartmentsSuccess])
  const formRef = React.createRef();

  const onFinish = (values) => {
    values = { ...values, registration_id };
    console.log(values);
    assignDocument(values);
  };

  const onChangeRadio = (e) => {
    setValue(e.target.value);
    console.log(value)
      if (value === "department") {
        setLists(allUsers);
      } else {
        setLists(allDepartments);
      }
    
  };
  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <PageHeader
          title="Assign Document"
          onBack={() => window.history.back()}
        />
        <Form layout="vertical" ref={formRef} onFinish={onFinish}>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={8}>
              <Form.Item label="Assign Type" name="assign_type" initialValue="department">
                <Radio.Group onChange={onChangeRadio} value={value}  >
                  <Radio value="department">Department</Radio>
                  <Radio value="user">User</Radio>
                </Radio.Group>
              </Form.Item>
            </Col>
            <Col span={10}>
              <Form.Item label="Assign To" name="assign_id">
                <Select placeholder="Select Assignee . . .">
                  {lists.map((list) => {
                    return (
                      <Select.Option key={list.id} value={list.id} >
                        {list.name}
                      </Select.Option>
                    );
                  })}
                </Select>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={18}>
              <Form.Item name="assign_remarks" label="Remarks">
                <TextArea rows={5}></TextArea>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={8}>
              <Form.Item  name="transfer_type" initialValue="forward_only">
                <Radio.Group> 
                  <Radio value="forward_only">Forward Only</Radio>
                  <Radio value="approve">Approve</Radio>
                  <Radio value="disapprove">Disapprove</Radio>
                </Radio.Group>
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={18}>
              <Button type="primary" htmlType="submit">
                Assign
              </Button>
            </Col>
          </Row>
        </Form>
      </Space>
    </>
  );
};

export default AssignDocument;
