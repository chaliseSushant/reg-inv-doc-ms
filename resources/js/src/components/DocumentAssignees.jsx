import { Card, Skeleton, Steps } from "antd";
import React, { useEffect } from "react";
import { useGetAssigneesQuery } from "../services/registrationApi";

const DocumentAssignees = ({ registration_id }) => {
  const { data: assignees, isLoading } = useGetAssigneesQuery(registration_id);
  if (isLoading) return <Skeleton active style={{width:400}} />;
  return (
    <>
       <Card title="Assignees" bordered={false} style={{width:400}} >
        <Steps direction="vertical">
          {assignees.map((assignee) => {
              return (
                <Steps.Step
                  title={assignee.name}
                  description={assignee.remarks}
                  status={assignee.approved_at !== null ? "finish" : "process"}
                />
              );
            })}
        </Steps>
      </Card>
    </>
  );
};

export default DocumentAssignees;
